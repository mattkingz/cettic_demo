using System.Collections;
using System.Collections.Generic;
using UnityEngine;
using System;

[Serializable]
public class GameConfig
{
    public string time_limit, score_per_item, player_speed;
}

public class DatabaseConnection : MonoBehaviour {

    private static DatabaseConnection instance;
    public static DatabaseConnection Instance
    {
        get
        {
            if (!instance) instance = GameObject.FindObjectOfType<DatabaseConnection>();
            return instance;
        }
    }

    public string server;

    void Start () {

	}
	
	void Update () {
		
	}

    //Registro de usuario
    public void SignUp(string username, string password1, string password2)
    {
        StartCoroutine(SignUpAssync(username, password1, password2));
    }
    

    IEnumerator SignUpAssync(string username, string password1, string password2)
    {
        UIManager.Instance.NowLoading();

        WWWForm form = new WWWForm();
        form.AddField("username", username);
        form.AddField("password1", password1);
        form.AddField("password2", password2);

        WWW www = new WWW(server + "add_user.php", form);

        yield return www;
        UIManager.Instance.FinishLoading();

        Debug.Log(www.text);
        if(www.text != "error")
        {
            GameManager.Instance.LoggedIn(username, int.Parse(www.text));
            GameManager.Instance.RestartGame();
        }
        else
        {
            UIManager.Instance.ShowError();
        }
        
    }

    //Inicio sesión
    public void Login(string username, string password)
    {
        StartCoroutine(LoginAssync(username, password));
    }

    IEnumerator LoginAssync(string username, string password)
    {
        UIManager.Instance.NowLoading();

        WWWForm form = new WWWForm();
        form.AddField("username", username);
        form.AddField("password", password);

        WWW www = new WWW(server + "check_login.php", form);

        yield return www;
        UIManager.Instance.FinishLoading();

        if(www.text != "error")
        {
            Debug.Log(www.text);
            GameManager.Instance.LoggedIn(username, int.Parse(www.text));
        }
        else
        {
            UIManager.Instance.ShowError("Usuario o contraseña incorrectas.");
        }

    }

    //Obtencion de parametros del juego de la BD
    public void UpdateGameConfig()
    {
        StartCoroutine(UpdateGameConfigAssync());
    }

    IEnumerator UpdateGameConfigAssync()
    {
        UIManager.Instance.NowLoading();

        WWW www = new WWW(server + "get_game_config.php");

        yield return www;
        UIManager.Instance.FinishLoading();

        GameConfig config = JsonUtility.FromJson<GameConfig>(www.text);

        GameManager.Instance.scorePerItem = float.Parse(config.score_per_item);
        GameManager.Instance.levelTime = float.Parse(config.time_limit);
        GameManager.Instance.playerSpeed = float.Parse(config.player_speed);

        GameManager.Instance.RestartGame();

    }

    //Insercion de puntaje en la BD cuando termina la partida
    public void PostScore(string user_id, string score)
    {
        StartCoroutine(PostScoreAssync(user_id, score));
    }

    IEnumerator PostScoreAssync(string user_id, string score)
    {
        UIManager.Instance.NowLoading();

        WWWForm form = new WWWForm();
        form.AddField("user_id", user_id);
        form.AddField("score", score);

        WWW www = new WWW(server + "post_score.php", form);

        yield return www;
        UIManager.Instance.FinishLoading();
        
    }
    
}
